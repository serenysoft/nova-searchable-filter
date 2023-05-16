<template>
  <div class="pt-2 pb-3">
    <h3 class="px-3 text-xs uppercase font-bold tracking-wide">
      {{ filter.name }}
    </h3>

    <div class="mt-1 px-3">
      <SearchInput
        ref="searchable"
        @input="performSearch"
        @selected="handleChange"
        :value="value"
        :data="availableResources"
        :clearable="false"
        trackBy="value"
        class="w-full"
      >
        <div v-if="value" class="flex items-center">
          <div v-if="value.avatar" class="mr-3">
            <img :src="value.avatar" class="w-6 h-6 rounded-full block" />
          </div>

          {{ value.display }}
        </div>

        <template #option="{ selected, option }">
          <div class="flex items-center">
            <div v-if="option.avatar" class="flex-none mr-3">
              <img :src="option.avatar" class="w-6 h-6 rounded-full block" />
            </div>

            <div class="flex-auto">
              <div class="text-sm font-semibold leading-normal" :class="{ 'text-white dark:text-gray-900': selected }">
                {{ option.display }}
              </div>

              <div v-if="filter.withSubtitles" class="text-xs font-semibold leading-normal text-gray-500"
                :class="{ 'text-white dark:text-gray-700': selected }">
                <span v-if="option.subtitle">{{ option.subtitle }}</span>
                <span v-else>{{ __('No additional information...') }}</span>
              </div>
            </div>
          </div>
        </template>
      </SearchInput>
    </div>
  </div>
</template>

<script>
import { PerformsSearches } from "laravel-nova"

export default {
  mixins: [PerformsSearches],

  props: {
    resourceName: {
      type: String,
      required: true,
    },
    filterKey: {
      type: String,
      required: true,
    },
  },

  methods: {
    getAvailableResources() {
      console.log(this);
      return this.fetchAvailableResources(
        this.resourceName,
        this.filter.relation,
        {
          params: {
            search: this.search,
          },
        }
      ).then(({ data: { resources } }) => {
        this.availableResources = resources;
      });
    },

    handleChange(resource) {
      this.$store.commit(`${this.resourceName}/updateFilterState`, {
        filterClass: this.filterKey,
        value: resource
      });

      this.$emit("change");
    },

    fetchAvailableResources(resourceName, relation, params) {
      return Nova.request().get(
        `/nova-api/${resourceName}/associatable/${relation}`,
        params
      );
    },

    determineIfSoftDeletes(resourceName) {
      return Nova.request().get(`/nova-api/${resourceName}/soft-deletes`);
    },
  },

  computed: {
    filter() {
      return this.$store.getters[`${this.resourceName}/getFilter`](
        this.filterKey
      );
    },

    value() {
      return this.filter.currentValue;
    },

    hasValue() {
      return this.value !== null && this.value !== '';
    }
  },
};
</script>
