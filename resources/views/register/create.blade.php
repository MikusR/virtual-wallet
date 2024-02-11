<x-layout>
    <section style="background-color: #a0aec0">
        create.blade.php
        <form method="post" action="/register">
            @csrf
            <label for="name">name:</label>
            <input type="text" name="name" id="name" required>

            <label for="password">password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Register</button>
        </form>
    </section>
</x-layout>
