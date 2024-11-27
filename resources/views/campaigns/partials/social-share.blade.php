<div class="flex gap-2 mt-4">
    <button 
        onclick="shareOnFacebook('{{ $campaign->title }}', '{{ url()->current() }}')"
        class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
        title="Share on Facebook"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
        </svg>
    </button>
    
    <button 
        onclick="shareOnTwitter('{{ $campaign->title }}', '{{ url()->current() }}')"
        class="p-2 text-sky-500 hover:bg-sky-50 rounded-full transition-colors"
        title="Share on Twitter"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
        </svg>
    </button>
    
    <button 
        onclick="shareOnWhatsApp('{{ $campaign->title }}', '{{ url()->current() }}')"
        class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
        title="Share on WhatsApp"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
        </svg>
    </button>
    
    <button 
        onclick="copyToClipboard('{{ url()->current() }}')"
        class="p-2 text-gray-600 hover:bg-gray-50 rounded-full transition-colors"
        title="Copy link"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
        </svg>
    </button>
</div>

<script>
function shareOnFacebook(title, url) {
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, 
        'facebook-share-dialog', 
        'width=800,height=600'
    );
}

function shareOnTwitter(title, url) {
    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`,
        'twitter-share-dialog',
        'width=800,height=600'
    );
}

function shareOnWhatsApp(title, url) {
    window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`,
        'whatsapp-share-dialog',
        'width=800,height=600'
    );
}

function copyToClipboard(url) {
    navigator.clipboard.writeText(url).then(() => {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Link copied to clipboard!';
        document.body.appendChild(toast);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}
</script>
