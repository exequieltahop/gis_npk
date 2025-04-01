<x-modal modal-id="modal-login"
    modal-title="Authorized User Only"
    modal-body-class="p-0">
    <x-form id="form-login"
            method="POST"
            action="{{ route('sign-in') }}"
            class="p-4 m-0"
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
            <x-button type="submit" class-type="dark">
                <i class="bi bi-box-arrow-in-right" style="font-style: normal;"> Sign In</i>
            </x-button>
        </div>
    </x-form>
</x-modal>