<v-cleo-lab-seeder></v-cleo-lab-seeder>

@pushOnce('scripts')
    <script type="text/x-template" id="v-cleo-lab-seeder-template">
        <div>
            <div class="mb-4 rounded-sm border border-amber-200 bg-amber-50 p-3 dark:border-amber-800 dark:bg-amber-900/20">
                <p class="mb-1 text-sm font-semibold text-amber-800 dark:text-amber-300">
                    @lang('nc::app.configuration.seeder_warning_title')
                </p>

                <ul class="list-disc pl-5 text-xs text-amber-700 dark:text-amber-400">
                    <li>@lang('nc::app.configuration.seeder_warning_idempotent')</li>
                    <li>@lang('nc::app.configuration.seeder_warning_sku')</li>
                </ul>
            </div>

            <div class="mb-4">
                <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">
                    @lang('nc::app.configuration.seeder_what_title')
                </p>

                <ul class="mb-4 list-disc pl-5 text-xs text-gray-600 dark:text-gray-300">
                    <li>@lang('nc::app.configuration.seeder_what_attributes')</li>
                    <li>@lang('nc::app.configuration.seeder_what_family')</li>
                    <li>@lang('nc::app.configuration.seeder_what_categories')</li>
                    <li>@lang('nc::app.configuration.seeder_what_products')</li>
                </ul>

                <button
                    type="button"
                    class="primary-button flex items-center gap-2"
                    :disabled="running"
                    @click="seed"
                >
                    <span
                        class="inline-block h-3.5 w-3.5 animate-spin rounded-full border-2 border-current border-t-transparent"
                        v-if="running"
                    ></span>

                    <span v-if="running">@lang('nc::app.configuration.seeder_running')</span>
                    <span v-else>@lang('nc::app.configuration.seeder_btn')</span>
                </button>
            </div>

            <div
                class="overflow-hidden rounded-sm border dark:border-gray-800"
                v-if="logs.length"
            >
                <div class="flex items-center justify-between border-b bg-gray-50 px-3 py-2 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs font-semibold text-gray-800 dark:text-white">
                        @lang('nc::app.configuration.seeder_console_title')
                    </p>

                    <button
                        type="button"
                        class="text-[11px] text-gray-500 underline hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                        @click="logs = []"
                    >
                        @lang('nc::app.configuration.seeder_console_clear')
                    </button>
                </div>

                <div
                    class="max-h-48 overflow-y-auto bg-gray-950 p-3"
                    ref="console"
                >
                    <div
                        v-for="(log, index) in logs"
                        :key="index"
                        class="mb-2 font-mono text-xs"
                        :class="{
                            'text-green-400': log.type === 'success',
                            'text-red-400':   log.type === 'error',
                            'text-gray-400':  log.type === 'info',
                        }"
                    >
                        <span class="select-none text-gray-600">@{{ log.time }}</span>
                        &nbsp;
                        <span v-if="log.type === 'success'">&#10003;</span>
                        <span v-if="log.type === 'error'">&#10007;</span>
                        &nbsp;@{{ log.message }}
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-cleo-lab-seeder', {
            template: '#v-cleo-lab-seeder-template',

            data() {
                return {
                    running: false,
                    logs: [],
                };
            },

            methods: {
                seed() {
                    if (this.running) {
                        return;
                    }

                    this.running = true;

                    this.logs.push({
                        type: 'info',
                        message: "@lang('nc::app.configuration.seeder_running')",
                        time: new Date().toLocaleTimeString('en-GB', { hour12: false }),
                    });

                    this.$axios.post("{{ route('admin.nebula-cosmetics.seed-demo-data') }}")
                        .then((response) => {
                            const data = response.data;

                            this.logs.push({
                                type: 'success',
                                message: data.message,
                                time: new Date().toLocaleTimeString('en-GB', { hour12: false }),
                            });

                            this.$emitter.emit('add-flash', {
                                type: 'success',
                                message: data.message,
                            });
                        })
                        .catch((error) => {
                            const msg = error.response?.data?.message || "@lang('nc::app.configuration.seeder_error')";

                            this.logs.push({
                                type: 'error',
                                message: msg,
                                time: new Date().toLocaleTimeString('en-GB', { hour12: false }),
                            });

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: msg,
                            });
                        })
                        .finally(() => {
                            this.running = false;

                            this.$nextTick(() => {
                                if (this.$refs.console) {
                                    this.$refs.console.scrollTop = this.$refs.console.scrollHeight;
                                }
                            });
                        });
                },
            },
        });
    </script>
@endPushOnce
