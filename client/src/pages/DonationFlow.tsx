import { useState } from "react";
import { CampaignGrid } from "../components/CampaignGrid";
import { DonationForm } from "../components/DonationForm";
import { useQuery } from "@tanstack/react-query";
import { fetchCampaigns } from "../lib/api";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";

export function DonationFlow() {
  const [selectedIds, setSelectedIds] = useState<number[]>([]);
  const [step, setStep] = useState<"select" | "donate">("select");
  
  const { data: campaigns } = useQuery({
    queryKey: ["campaigns"],
    queryFn: fetchCampaigns,
  });

  const handleSelect = (id: number) => {
    setSelectedIds(prev => {
      if (prev.includes(id)) {
        return prev.filter(x => x !== id);
      }
      if (prev.length >= 5) return prev;
      return [...prev, id];
    });
  };

  return (
    <div className="container mx-auto px-4 py-8">
      {step === "select" ? (
        <>
          <h1 className="text-3xl font-bold mb-8">Select Campaigns (Up to 5)</h1>
          <CampaignGrid
            campaigns={campaigns || []}
            selectedIds={selectedIds}
            onSelect={handleSelect}
            selectable
          />
          <div className="mt-8 flex justify-center">
            <Button
              disabled={selectedIds.length === 0}
              onClick={() => setStep("donate")}
              size="lg"
            >
              Continue to Donation
            </Button>
          </div>
        </>
      ) : (
        <Card className="max-w-2xl mx-auto p-6">
          <DonationForm
            selectedCampaigns={campaigns?.filter(c => selectedIds.includes(c.id)) || []}
            onBack={() => setStep("select")}
          />
        </Card>
      )}
    </div>
  );
}
