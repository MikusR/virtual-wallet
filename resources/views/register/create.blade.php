<x-layout>
    <section>

        <div class="container">
            <form method="post" action="/register">
                @csrf
                <label for="name">name:</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}">
                @error('name')
                <p>{{ $message }}</p>
                @enderror
                <label for="email">email:</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
                @error('email')
                <p>{{ $message }}</p>
                @enderror
                <label for="password">password:</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                <p>{{ $message }}</p>
                @enderror
                <button type="submit">Register</button>
            </form>
        </div>

    </section>
</x-layout>
