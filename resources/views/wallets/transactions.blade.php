<x-layout>
    <section>


        @if (request()->routeIs('wallets.edit'))
            <div class="container">
                <form method="post" action="/wallets/{{ $wallet->id }}/update">
                    @csrf
                    <label for="name">name:</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $wallet->name) }}">
                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                    <button type="submit">Rename</button>
                </form>
            </div>
        @else
            <div>
                <h2>{{ $wallet->name }}</h2>
            </div>
        @endif

        <a href="/transactions/create">Create transaction</a>
        <table class="container">
            <thead>
            <tr>
                <th scope="col">group_id</th>
                <th scope="col">amount</th>
                <th scope="col">type</th>
                <th scope="col">is_fraudulent</th>

                <th scope="col">created_at</th>

            </tr>
            </thead>
            <tbody>


            @foreach($wallet->transactions as $transaction)
                <tr>
                    <th scope="row"><a href="/transaction/{{ $transaction->group_id }}">{{ $transaction->group_id }}</a>
                    </th>
                    <td>{{ $transaction->amount }}</td>
                    @if ($transaction->type === 'in')
                        <td>Incoming</td>
                    @endif
                    @if ($transaction->type === 'out')
                        <td>Outgoing</td>
                    @endif

                    <td>{{ $transaction->is_fraudulent }}</td>
                    <td>{{ $transaction->created_at }}</td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </section>
</x-layout>
