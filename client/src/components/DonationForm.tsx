import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { Button } from "@/components/ui/button";
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { useMutation } from "@tanstack/react-query";
import { submitDonation } from "../lib/api";
import { useToast } from "@/hooks/use-toast";
import { useLocation } from "wouter";
import type { Campaign } from "@db/schema";

const formSchema = z.object({
  email: z.string().email(),
  amount: z.string().regex(/^\d+(\.\d{1,2})?$/),
  recurring: z.number().default(0),
});

interface DonationFormProps {
  selectedCampaigns: Campaign[];
  onBack: () => void;
}

export function DonationForm({ selectedCampaigns, onBack }: DonationFormProps) {
  const { toast } = useToast();
  const [_, setLocation] = useLocation();
  
  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      email: "",
      amount: "",
      recurring: 0,
    },
  });

  const mutation = useMutation({
    mutationFn: submitDonation,
    onSuccess: () => {
      toast({
        title: "Donation Successful",
        description: "Thank you for your support! You will receive an email confirmation shortly.",
      });
      setLocation("/");
    },
  });

  const onSubmit = (values: z.infer<typeof formSchema>) => {
    mutation.mutate({
      ...values,
      campaignIds: selectedCampaigns.map((c: Campaign) => c.id.toString()).join(","),
    });
  };

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
        <FormField
          control={form.control}
          name="email"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Email</FormLabel>
              <FormControl>
                <Input {...field} type="email" />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        
        <FormField
          control={form.control}
          name="amount"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Donation Amount ($)</FormLabel>
              <FormControl>
                <Input {...field} type="number" step="0.01" min="1" />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />

        <FormField
          control={form.control}
          name="recurring"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Donation Frequency</FormLabel>
              <FormControl>
                <RadioGroup
                  onValueChange={(value) => field.onChange(Number(value))}
                  defaultValue={String(field.value)}
                  className="flex flex-col space-y-2"
                >
                  <div className="flex items-center space-x-2">
                    <RadioGroupItem value="0" id="one-time" />
                    <label htmlFor="one-time">One-time donation</label>
                  </div>
                  <div className="flex items-center space-x-2">
                    <RadioGroupItem value="7" id="weekly" />
                    <label htmlFor="weekly">Weekly for 7 days</label>
                  </div>
                </RadioGroup>
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />

        <div className="flex justify-between">
          <Button type="button" className="bg-transparent hover:bg-gray-100 border border-gray-300" onClick={onBack}>
            Back
          </Button>
          <Button type="submit" disabled={mutation.isPending}>
            {mutation.isPending ? "Processing..." : "Complete Donation"}
          </Button>
        </div>
      </form>
    </Form>
  );
}
