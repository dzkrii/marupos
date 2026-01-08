<x-app-layout>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metrics -->
            <x-dashboard.metrics />

            <!-- Monthly Sales Chart -->
            <x-dashboard.monthly-sale />
        </div>

        <div class="col-span-12 xl:col-span-5">
            <!-- Monthly Target -->
            <x-dashboard.monthly-target />
        </div>
    </div>
</x-app-layout>
