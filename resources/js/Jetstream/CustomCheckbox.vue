<template>
    <div class="flex">
        <div class="flex items-center h-5">
            <jet-checkbox @update:checked="updated(checkbox.value)" :ref="checkbox.name" :id="checkbox.name"
                          :name="checkbox.name" :checked="selectedOptions[key]"></jet-checkbox>
        </div>
        <div class="ml-3 text-sm">
            <label :for="checkbox.name"
                   class="font-medium text-gray-700 dark:text-gray-200" v-text="checkbox.label"/>
            <p class="dark:text-gray-400 text-gray-500" v-text="checkbox.description"/>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
