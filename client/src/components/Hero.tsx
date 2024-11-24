import React from 'react'

export default function Hero() {
  return (
    <div className="relative h-[500px] flex items-center justify-center">
      <div 
        className="absolute inset-0 bg-cover bg-center"
        style={{ 
          backgroundImage: 'url("https://images.unsplash.com/photo-1637034318492-c5d36e4f6d99")',
          filter: 'brightness(0.6)'
        }}
      />
      <div className="relative z-10 text-center text-white max-w-3xl px-4">
        <h1 className="text-5xl font-bold mb-6">Support Palestinian Communities</h1>
        <p className="text-xl mb-8">
          Join us in making a difference through verified humanitarian campaigns.
          Every donation brings hope and support to those in need.
        </p>
        <a 
          href="#campaigns"
          className="inline-block px-6 py-3 bg-olive-700 hover:bg-olive-800 text-white font-semibold rounded-lg transition-colors"
        >
          View Campaigns
        </a>
      </div>
    </div>
  )
}
