<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Create Ticket
        </h2>
    </x-slot>

    <div class="p-6">



        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            <div>
                <label>Ticket Name</label><br>
                <input type="text" name="name" required>
            </div><br>

            <div>
                <label>Ticket Type</label><br>
                <select name="type" required>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div><br>

            <div>
                <label>Transport Mode</label><br>
                <select name="transport_mode" required>
                    @foreach ($transportModes as $mode)
                        <option value="{{ $mode }}">{{ ucfirst($mode) }}</option>
                    @endforeach
                </select>
            </div><br>

            <div>
                <label>Product</label><br>
                <input type="text" name="product" required>
            </div><br>

            <div>
                <label>Country of Origin</label><br>
                <input type="text" name="country_origin" required>
            </div><br>

            <div>
                <label>Country of Destination</label><br>
                <input type="text" name="country_destination" required>
            </div><br>


            <div class="flex items-center justify-start ">
                <a href="{{ route('tickets.index') }}"
                    style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; border: none;margin-right: 10px;">
                    Cancel
                </a>

                <button type="submit"
                    style="background-color: green; color: white; padding: 10px 20px; border-radius: 5px; border: none;">
                    Create Ticket
                </button>

            </div>

        </form>

    </div>
</x-app-layout>