<x-layout>
    <section>
        <div class="container">
            <form method="post" action="/{{ Auth::user()->id }}/wallets/transactions/create">
                @csrf
                <label for="from">From:</label>
                <select name="from" id="from" required>
                    @foreach ($wallets as $wallet)
                        <option value="{{ $wallet->id }}">{{ $wallet->name }} (Balance: {{ $wallet->balance }})</option>
                    @endforeach
                </select>
                @error('from')
                <p>{{ $message }}</p>
                @enderror
                <label for="to">To:</label>
                <input type="text" name="to" id="to" required value="{{ old('to') }}">
                @error('to')
                <p>{{ $message }}</p>
                @enderror
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount" required value="{{ old('amount') }}">
                @error('amount')
                <p>{{ $message }}</p>
                @enderror
                <button type="submit">Send</button>
            </form>
        </div>

    </section>
</x-layout>
