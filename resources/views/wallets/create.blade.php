<x-layout>
    <section>
        <div class="container">
            <form method="post" action="/wallets/create">
                @csrf
                <label for="name">name:</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}">
                @error('name')
                <p>{{ $message }}</p>
                @enderror
                <button type="submit">Create</button>
            </form>
        </div>

    </section>
</x-layout>
