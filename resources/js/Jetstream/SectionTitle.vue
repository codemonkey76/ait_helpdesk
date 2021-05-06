<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium dark:text-gray-400 text-gray-900">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1 text-sm dark:text-gray-500 text-gray-600">
                <slot name="description"></slot>
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside"></slot>
        </div>
    </div>
</template>
