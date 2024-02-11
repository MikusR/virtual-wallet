<x-layout>
    <section>
        <div class="container">
            <form method="post" action="/login">
                @csrf
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
                <button type="submit">Login</button>
            </form>
        </div>

    </section>
</x-layout>
