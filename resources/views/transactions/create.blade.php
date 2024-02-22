<x-layout>
    <section>
        <div class="container">
            <form method="post" action="/wallets/{{ $wallet->id }}/transactions/create">
                @csrf
                <label for="from">From:</label>
                <input type="text" name="from" id="from" required value="{{ old('from', $wallet->id) }}">
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
