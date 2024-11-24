import React from 'react'
import { useQuery } from '@tanstack/react-query'
import { getCampaigns } from '../lib/api'
import Hero from '../components/Hero'
import CampaignGrid from '../components/CampaignGrid'

export default function HomePage() {
  const { data: campaigns, isLoading } = useQuery({
    queryKey: ['campaigns'],
    queryFn: getCampaigns,
  })

  return (
    <div className="min-h-screen">
      <Hero />
      <main className="container mx-auto px-4 py-8">
        {isLoading ? (
          <div>Loading campaigns...</div>
        ) : (
          <CampaignGrid campaigns={campaigns || []} />
        )}
      </main>
    </div>
  )
}
