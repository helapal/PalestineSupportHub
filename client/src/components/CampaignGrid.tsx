import React from 'react'
import { Campaign } from '../lib/api'
import CampaignCard from './CampaignCard'

interface CampaignGridProps {
  campaigns: Campaign[]
}

export default function CampaignGrid({ campaigns }: CampaignGridProps) {
  return (
    <div>
      <h2 className="text-3xl font-bold mb-8 text-olive-800">Active Campaigns</h2>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {campaigns.map((campaign) => (
          <CampaignCard key={campaign.id} campaign={campaign} />
        ))}
      </div>
    </div>
  )
}
