import React from 'react'
import { Campaign } from '../lib/api'

interface CampaignCardProps {
  campaign: Campaign
}

export default function CampaignCard({ campaign }: CampaignCardProps) {
  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden">
      <div 
        className="h-48 bg-cover bg-center"
        style={{ backgroundImage: `url(${campaign.image_url})` }}
      />
      <div className="p-4">
        <h3 className="text-xl font-bold mb-2">{campaign.title}</h3>
        <p className="text-gray-600 mb-4 line-clamp-2">{campaign.description}</p>
        <div className="space-y-2">
          <div className="w-full bg-gray-200 rounded-full h-2">
            <div 
              className="bg-olive-700 h-2 rounded-full"
              style={{ width: `${(campaign.current / campaign.goal) * 100}%` }}
            />
          </div>
          <div className="flex justify-between text-sm">
            <span>${campaign.current.toFixed(2)}</span>
            <span>Goal: ${campaign.goal.toFixed(2)}</span>
          </div>
        </div>
      </div>
    </div>
  )
}
