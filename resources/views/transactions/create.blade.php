<x-layout>
    <section>
        <div class="container">
            @if($wallets->count() > 1)
                <details open>
                    <summary>Transfer between you wallets</summary>
                    <form method="post" action="/{{ Auth::user()->id }}/wallets/transactions/create">
                        @csrf
                        <label for="from">From:</label>
                        <select name="from" id="from" required>
                            @foreach ($wallets as $wallet)
                                <option @if(old('from', $wallet_id) == $wallet->id)
                                            selected
                                        @endif value="{{ $wallet->id }}">{{ $wallet->name }}
                                    (Balance: {{ $wallet->balance }})
                                </option>
                            @endforeach
                        </select>
                        @error('from')
                        <p>{{ $message }}</p>
                        @enderror
                        <label for="to">To:</label>
                        <select name="to" id="to" required>
                            @foreach ($wallets as $wallet)
                                <option @if(old('to') == $wallet->id)
                                            selected
                                        @endif value="{{ $wallet->id }}">{{ $wallet->name }}
                                    (Balance: {{ $wallet->balance }})
                                </option>
                            @endforeach
                        </select>

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
                </details>
                <hr/>
            @endif


            <details @if($wallets->count() == 1)open @endif>
                <summary>Transfer to wallets of other users</summary>
                <form method="post" action="/{{ Auth::user()->id }}/wallets/transactions/create">
                    @csrf
                    <label for="other-from">From:</label>
                    <select name="from" id="other-from" required>
                        @foreach ($wallets as $wallet)
                            <option @if(old('from', $wallet_id) == $wallet->id)
                                        selected
                                    @endif value="{{ $wallet->id }}">{{ $wallet->name }}
                                (Balance: {{ $wallet->balance }})
                            </option>
                        @endforeach
                    </select>
                    @error('from')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="other-to">Enter wallet number to:</label>
                    <input type="text" name="to" id="other-to" required>

                    @error('to')
                    <p>{{ $message }}</p>
                    @enderror
                    <label for="other-amount">Amount:</label>
                    <input type="text" name="amount" id="other-amount" required value="{{ old('amount') }}">
                    @error('amount')
                    <p>{{ $message }}</p>
                    @enderror
                    <button type="submit">Send</button>
                </form>
            </details>

        </div>

    </section>
</x-layout>
