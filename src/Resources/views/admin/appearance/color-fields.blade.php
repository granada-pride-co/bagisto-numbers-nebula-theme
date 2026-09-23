@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-section-fields-template-enhanced"
    >
        <div class="grid min-w-0 gap-4">
            <template v-for="field in schema" :key="field.key">
                <div v-if="field.type === 'repeater'">
                    <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <draggable
                        class="grid gap-3"
                        ghost-class="draggable-ghost"
                        v-bind="{animation: 200}"
                        :list="rowsOf(field)"
                        :item-key="rowKey"
                        handle=".repeater-handle"
                        @end="bubble"
                    >
                        <template #item="{ element: row, index }">
                            <div class="rounded border border-gray-200 p-3 dark:border-gray-800">
                                <div class="mb-2 flex items-center gap-2">
                                    <span class="repeater-handle icon-drag cursor-grab text-lg text-gray-400"></span>

                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-300">
                                        #@{{ index + 1 }}
                                    </span>

                                    <button
                                        type="button"
                                        class="icon-delete cursor-pointer text-xl text-gray-400 hover:text-red-600 ltr:ml-auto rtl:mr-auto"
                                        @click="removeRow(field, index)"
                                    ></button>
                                </div>

                                <v-section-fields
                                    :schema="field.fields"
                                    :model="row"
                                    :section-id="sectionId"
                                    :media-url="mediaUrl"
                                    :media-base="mediaBase"
                                    @change="bubble"
                                ></v-section-fields>
                            </div>
                        </template>
                    </draggable>

                    <button
                        type="button"
                        class="secondary-button mt-2 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isFull(field)"
                        @click="addRow(field)"
                    >
                        @{{ field.add_label ?? field.label }}
                    </button>
                </div>

                <div v-else-if="field.type === 'filters'">
                    <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <div class="grid gap-2">
                        <div
                            class="grid gap-1"
                            v-for="(pair, index) in filterPairs"
                            :key="index"
                        >
                            <div class="flex items-center gap-2">
                                <v-select
                                    class="min-w-0 flex-1"
                                    :name="'filter-key-' + index"
                                    :options="keyOptionsFor(field, index).map(option => ({ id: option.value, label: option.label }))"
                                    :value="pair.key"
                                    @update:model-value="key => changeKey(field, pair, key)"
                                ></v-select>

                                <v-multiselect
                                    class="min-w-0 flex-1"
                                    :name="'filter-' + pair.key"
                                    :options="pickerOptionsFor(field, pair)"
                                    :value="listValue(pair)"
                                    :placeholder="labelFor(field, pair.key)"
                                    v-if="isMultiple(field, pair.key)"
                                    @update:model-value="ids => { pair.value = ids.join(','); syncFilters(field); }"
                                ></v-multiselect>

                                <v-select
                                    class="min-w-0 flex-1"
                                    :name="'filter-' + pair.key"
                                    :options="pickerOptionsFor(field, pair)"
                                    :value="pair.value"
                                    :placeholder="labelFor(field, pair.key)"
                                    v-else-if="optionsFor(field, pair.key).length"
                                    @update:model-value="value => { pair.value = value; syncFilters(field); }"
                                ></v-select>

                                <input
                                    type="text"
                                    class="min-w-0 flex-1 rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                    v-model="pair.value"
                                    v-else
                                    @input="syncFilters(field)"
                                />

                                <button
                                    type="button"
                                    class="icon-delete shrink-0 cursor-pointer text-xl text-gray-400 hover:text-red-600"
                                    @click="removeFilter(field, index)"
                                ></button>
                            </div>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="secondary-button mt-2 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="allFiltersUsed(field)"
                        :title="allFiltersUsed(field)
                            ? '@lang('admin::app.appearance.sections.index.all-filters-used')'
                            : ''"
                        @click="addFilter(field)"
                    >
                        @{{ field.add_label ?? field.label }}
                    </button>
                </div>

                <div v-else-if="field.type === 'image'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <div class="flex items-center gap-3">
                        <img
                            class="h-16 w-24 rounded border border-gray-200 object-cover dark:border-gray-800"
                            :src="imageSrc(field)"
                            v-if="model[field.key]"
                        />

                        <label class="secondary-button cursor-pointer">
                            @lang('admin::app.appearance.sections.edit.image')

                            <input
                                type="file"
                                class="hidden"
                                accept="image/*"
                                @change="upload(field, $event)"
                            />
                        </label>
                    </div>
                </div>

                <div v-else-if="field.type === 'code'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <v-code-editor
                        :language="field.language"
                        :model-value="model[field.key]"
                        :section-id="sectionId"
                        :media-url="mediaUrl"
                        :media-base="mediaBase"
                        @update:model-value="value => { model[field.key] = value; bubble(); }"
                    ></v-code-editor>
                </div>

                <div v-else-if="field.type === 'number'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <input
                        type="number"
                        min="0"
                        class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                        v-model="model[field.key]"
                        @input="bubble"
                    />
                </div>

                <div v-else-if="field.type === 'textarea'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <textarea
                        class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                        rows="3"
                        v-model="model[field.key]"
                        @input="bubble"
                    ></textarea>
                </div>

                <div v-else-if="field.type === 'color'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <div class="flex items-center gap-2">
                        <div class="relative flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-md border border-gray-300 shadow-sm transition hover:border-gray-400 dark:border-gray-700">
                            <input
                                type="color"
                                class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                                :value="model[field.key] || '#ffffff'"
                                @input="model[field.key] = $event.target.value; bubble();"
                            />
                            <span
                                class="h-full w-full rounded"
                                :style="{ backgroundColor: model[field.key] || '#ffffff' }"
                            ></span>
                        </div>

                        <input
                            type="text"
                            class="min-w-0 flex-1 rounded-md border px-3 py-2.5 font-mono text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                            placeholder="#000000"
                            v-model="model[field.key]"
                            @input="bubble"
                        />
                    </div>
                </div>

                <div v-else-if="field.type === 'select'">
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <select
                        class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                        v-model="model[field.key]"
                        @change="bubble"
                    >
                        <option
                            v-for="opt in (field.options || [])"
                            :key="opt.value !== undefined ? opt.value : opt"
                            :value="opt.value !== undefined ? opt.value : opt"
                        >
                            @{{ opt.label !== undefined ? opt.label : opt }}
                        </option>
                    </select>
                </div>

                <div v-else>
                    <p class="mb-1.5 text-xs font-medium text-gray-800 dark:text-white">
                        @{{ field.label }}
                    </p>

                    <input
                        type="text"
                        class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                        v-model="model[field.key]"
                        @input="bubble"
                    />
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        const existing = app._context.components['v-section-fields'];
        if (
            existing
            && ! existing.methods?.isColorField
        ) {
            app.component('v-section-fields', {
                ...existing,
                template: '#v-section-fields-template-enhanced',
            });
        }
    </script>
@endPushOnce
