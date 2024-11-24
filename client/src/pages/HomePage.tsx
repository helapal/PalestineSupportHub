import { Hero } from "../components/Hero";
import { CampaignGrid } from "../components/CampaignGrid";
import { useQuery } from "@tanstack/react-query";
import { fetchCampaigns } from "../lib/api";
import { Skeleton } from "@/components/ui/skeleton";

export function HomePage() {
  const { data: campaigns, isLoading } = useQuery({
    queryKey: ["campaigns"],
    queryFn: fetchCampaigns,
  });

  return (
    <div className="min-h-screen">
      <Hero />
      <main className="container mx-auto px-4 py-8">
        <h2 className="text-3xl font-bold mb-8 text-olive-800">Active Campaigns</h2>
        {isLoading ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {[...Array(6)].map((_, i) => (
              <Skeleton key={i} className="h-[400px] w-full" />
            ))}
          </div>
        ) : (
          <CampaignGrid campaigns={campaigns || []} />
        )}
      </main>
    </div>
  );
}
