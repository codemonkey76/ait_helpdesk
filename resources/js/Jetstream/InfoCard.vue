<template>
    <div class="flex p-6">
        <slot name="image">
        </slot>
        <div class="ml-4">
            <div class="text-lg leading-7 font-semibold">
                <slot name="title">
                </slot>
            </div>

            <div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    <slot name="body" class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
