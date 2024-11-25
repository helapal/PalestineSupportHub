<form action="{{ route('campaigns.donate') }}" method="POST" class="donation-form flex gap-4">
    @csrf
    <input type="hidden" name="campaign_ids" value="{{ $campaign->id }}">
    <input 
        type="email" 
        name="email" 
        placeholder="Your email"
        required
        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
        title="Please enter a valid email address"
        class="flex-1 px-3 py-2 border rounded-lg"
    >
    <input 
        type="number" 
        name="amount" 
        placeholder="Amount"
        min="1"
        step="0.01"
        required
        class="w-24 px-3 py-2 border rounded-lg"
    >
    <input type="hidden" name="recurring" value="0">
    <button 
        type="submit"
        class="px-4 py-2 bg-olive-700 hover:bg-olive-800 text-white font-semibold rounded-lg transition-colors"
        onclick="return confirmDonation(this.form)"
    >
        Donate
    </button>
</form>

<script>
function confirmDonation(form) {
    const email = form.querySelector('[name="email"]');
    const amount = form.querySelector('[name="amount"]');
    
    if (!email.validity.valid) {
        alert('Please enter a valid email address');
        email.focus();
        return false;
    }
    
    if (!amount.validity.valid || amount.value <= 0) {
        alert('Please enter a valid donation amount (minimum $1)');
        amount.focus();
        return false;
    }
    
    return confirm(`Confirm donation of $${parseFloat(amount.value).toFixed(2)}?`);
}
</script>
