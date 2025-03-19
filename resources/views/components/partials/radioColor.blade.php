<div x-data="{
    colors: [
        { value: 'red', label: 'Red' },
        { value: 'amber', label: 'Amber' },
        { value: 'sky', label: 'Sky' },
        { value: 'blue', label: 'Blue' },
        { value: 'violet', label: 'Violet' },
        { value: 'green', label: 'Green' },
        { value: 'orange', label: 'Orange' },
        { value: 'pink', label: 'Pink' }
    ],
    getColorClasses(color) {
        const classes = {
            red: {
                bg: 'bg-red-500',
                border: 'border-red-600',
                hover: 'hover:border-red-400',
                checkedBorder: 'peer-checked:border-red-500',
                checkedShadow: 'peer-checked:shadow-red-400',
                checkedText: 'peer-checked:text-red-500'
            },
            orange: {
                bg: 'bg-orange-500',
                border: 'border-orange-600',
                hover: 'hover:border-orange-400',
                checkedBorder: 'peer-checked:border-orange-500',
                checkedShadow: 'peer-checked:shadow-orange-400',
                checkedText: 'peer-checked:text-orange-500'
            },
            amber: {
                bg: 'bg-amber-500',
                border: 'border-amber-600',
                hover: 'hover:border-amber-400',
                checkedBorder: 'peer-checked:border-amber-500',
                checkedShadow: 'peer-checked:shadow-amber-400',
                checkedText: 'peer-checked:text-amber-500'
            },
            sky: {
                bg: 'bg-sky-500',
                border: 'border-sky-600',
                hover: 'hover:border-sky-400',
                checkedBorder: 'peer-checked:border-sky-500',
                checkedShadow: 'peer-checked:shadow-sky-400',
                checkedText: 'peer-checked:text-sky-500'
            },
            blue: {
                bg: 'bg-blue-500',
                border: 'border-blue-600',
                hover: 'hover:border-blue-400',
                checkedBorder: 'peer-checked:border-blue-500',
                checkedShadow: 'peer-checked:shadow-blue-400',
                checkedText: 'peer-checked:text-blue-500'
            },
            violet: {
                bg: 'bg-violet-500',
                border: 'border-violet-600',
                hover: 'hover:border-violet-400',
                checkedBorder: 'peer-checked:border-violet-500',
                checkedShadow: 'peer-checked:shadow-violet-400',
                checkedText: 'peer-checked:text-violet-500'
            },
            green: {
                bg: 'bg-green-500',
                border: 'border-green-600',
                hover: 'hover:border-green-400',
                checkedBorder: 'peer-checked:border-green-500',
                checkedShadow: 'peer-checked:shadow-green-400',
                checkedText: 'peer-checked:text-green-500'
            },
            pink: {
                bg: 'bg-pink-500',
                border: 'border-pink-600',
                hover: 'hover:border-pink-400',
                checkedBorder: 'peer-checked:border-pink-500',
                checkedShadow: 'peer-checked:shadow-pink-400',
                checkedText: 'peer-checked:text-pink-500'
            }
        };
        return classes[color] || classes.blue; // Default to blue if color not found
    }
}">
    <div class="grid grid-cols-2 gap-2">
        <template x-for="color in colors" :key="color.value">
            <label :for="color.value">
                <input class="peer sr-only" :value="color.value" name="color" :id="color.value" type="radio" x-model="frameColor" />
                <div class="flex px-4 py-2 cursor-pointer flex-row gap-2 items-center rounded-lg border-1 border-slate-300 shadow-sm bg-gray-50 p-1 transition-transform duration-150 active:scale-95 peer-checked:shadow-md"
                    :class="[
                        getColorClasses(color.value).hover,
                        getColorClasses(color.value).checkedBorder,
                        getColorClasses(color.value).checkedShadow
                    ]">
                    <div class="w-5 h-5 rounded-sm shadow-sm"
                        :class="[
                            getColorClasses(color.value).bg,
                            getColorClasses(color.value).border
                        ]"></div>
                    <span class="flex cursor-pointer items-center capitalize justify-center text-sm font-medium text-gray-800 leading-2 tracking-wide"
                        :class="getColorClasses(color.value).checkedText"
                        x-text="color.label"></span>
                </div>
            </label>
        </template>
    </div>
</div>
