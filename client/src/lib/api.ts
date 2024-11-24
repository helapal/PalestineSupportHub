import { type Campaign, type InsertDonation } from "@db/schema";

export async function fetchCampaigns(): Promise<Campaign[]> {
  const response = await fetch("/api/campaigns");
  if (!response.ok) throw new Error("Failed to fetch campaigns");
  return response.json();
}

export async function submitDonation(donation: InsertDonation) {
  const response = await fetch("/api/donations", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(donation),
  });
  if (!response.ok) throw new Error("Failed to submit donation");
  return response.json();
}
