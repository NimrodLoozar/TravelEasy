<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')

        <div>
            <x-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $customer->name }}"
                required autofocus />
        </div>

        <div class="mt-4">
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                value="{{ $customer->email }}" required />
        </div>

        <div class="mt-4">
            <x-label for="phone" :value="__('Phone')" />
            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                value="{{ $customer->phone }}" required />
        </div>

        <div class="mt-4">
            <x-label for="address" :value="__('Address')" />
            <x-input id="address" class="block mt-1 w-full" type="text" name="address"
                value="{{ $customer->address }}" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Update') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
