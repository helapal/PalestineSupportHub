import { type Campaign } from "@db/schema";
import { CampaignCard } from "./CampaignCard";

interface CampaignGridProps {
  campaigns: Campaign[];
  selectedIds?: number[];
  onSelect?: (id: number) => void;
  selectable?: boolean;
}

export function CampaignGrid({ campaigns, selectedIds = [], onSelect, selectable = false }: CampaignGridProps) {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      {campaigns.map((campaign) => (
        <CampaignCard
          key={campaign.id}
          campaign={campaign}
          selected={selectedIds.includes(campaign.id)}
          onSelect={() => onSelect?.(campaign.id)}
          selectable={selectable}
        />
      ))}
    </div>
  );
}
