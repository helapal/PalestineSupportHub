import { Card, CardContent, CardFooter, CardHeader } from "@/components/ui/card";
import { Progress } from "@/components/ui/progress";
import { Button } from "@/components/ui/button";
import { type Campaign } from "@db/schema";
import { useNavigate } from "wouter";

interface CampaignCardProps {
  campaign: Campaign;
  selected?: boolean;
  onSelect?: () => void;
  selectable?: boolean;
}

export function CampaignCard({ campaign, selected, onSelect, selectable }: CampaignCardProps) {
  const navigate = useNavigate();
  const progress = (Number(campaign.current) / Number(campaign.goal)) * 100;

  return (
    <Card className={`overflow-hidden transition-all ${selected ? 'ring-2 ring-primary' : ''}`}>
      <CardHeader className="p-0">
        <div
          className="h-48 bg-cover bg-center"
          style={{ backgroundImage: `url(${campaign.imageUrl})` }}
        />
      </CardHeader>
      <CardContent className="p-4">
        <h3 className="text-xl font-bold mb-2">{campaign.title}</h3>
        <p className="text-gray-600 mb-4 line-clamp-2">{campaign.description}</p>
        <div className="space-y-2">
          <Progress value={progress} className="h-2" />
          <div className="flex justify-between text-sm">
            <span>${Number(campaign.current).toLocaleString()}</span>
            <span>Goal: ${Number(campaign.goal).toLocaleString()}</span>
          </div>
        </div>
      </CardContent>
      <CardFooter className="p-4 pt-0">
        {selectable ? (
          <Button
            onClick={onSelect}
            variant={selected ? "default" : "outline"}
            className="w-full"
          >
            {selected ? "Selected" : "Select Campaign"}
          </Button>
        ) : (
          <Button 
            onClick={() => navigate("/donate")} 
            className="w-full"
          >
            Donate Now
          </Button>
        )}
      </CardFooter>
    </Card>
  );
}
