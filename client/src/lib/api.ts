import axios from 'axios'

export interface Campaign {
  id: number
  title: string
  description: string
  image_url: string
  goal: number
  current: number
  gofundme_url: string
  created_at: string
  updated_at: string
}

const api = axios.create({
  baseURL: '/api'
})

export const getCampaigns = async (): Promise<Campaign[]> => {
  const response = await api.get('/campaigns')
  return response.data
}

export const makeDonation = async (data: {
  email: string
  amount: number
  campaign_ids: string
  recurring: number
}) => {
  const response = await api.post('/donate', data)
  return response.data
}
