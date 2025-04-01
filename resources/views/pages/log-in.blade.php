<x-guest-layout>
    <section class="container vh-100 d-grid" style="place-items: center;">
        <x-form id="form-login"
                method="POST"
                action=""
                class="p-4"
                style="max-width: 500px;">

            @csrf
            <x-input type="email"
                     id="email"
                     name="email"
                     label="Email"
                     class=""
                     input-class=""
                     :required="true"/>

            <x-input type="password"
                     id="password"
                     name="password"
                     label="Password"
                     class=""
                     input-class=""
                     :required="true"/>
            {{-- btn --}}
            <div class="d-flex justify-content-end align-items-center gap-2" >
                <x-button type="button" class-type="primary">Sign up</x-button>
                <x-button type="submit" class-type="primary">Sign in</x-button>
            </div>
        </x-form>
    </section>
</x-guest-layout>