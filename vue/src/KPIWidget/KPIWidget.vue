<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div
    v-if="cardTitle"
    class="card"
  >
    <div class="card-content">
      <h2 class="card-title">{{ cardTitle }}</h2>
      <div class="kpiWidget">
        <MetricValue :value="displayValue">
          <template
            v-if="evolution"
            #evolution
          >
            <EvolutionBadge
              :percent="evolution.percent"
              :trend="evolution.trend"
              :is-lower-value-better="isLowerValueBetter"
            />
          </template>
        </MetricValue>
      </div>
    </div>
  </div>
  <div
    v-else
    class="kpiWidget"
  >
    <MetricValue :value="displayValue">
      <template
        v-if="evolution"
        #evolution
      >
        <EvolutionBadge
          :percent="evolution.percent"
          :trend="evolution.trend"
          :is-lower-value-better="isLowerValueBetter"
        />
      </template>
    </MetricValue>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import { EvolutionBadge, MetricValue } from 'CoreVisualizations';

export interface KPIEvolution {
  percent: string | number;
  trend: number;
}

/**
 * Single KPI readout for dashboard widgets. Composes the core MetricValue + EvolutionBadge atoms;
 * plugin.less lays them out as a large centered value with the badge below. When a card title is
 * given (reporting page, not widgetized) the readout is wrapped in a card, as Matomo does not add
 * one for controller-rendered widgets.
 */
export default defineComponent({
  name: 'KPIWidget',
  components: {
    MetricValue,
    EvolutionBadge,
  },
  props: {
    // already formatted server side (number, percent, duration or money)
    value: {
      type: [String, Number],
      default: '',
    },
    evolution: {
      type: Object as PropType<KPIEvolution | null>,
      default: null,
    },
    isLowerValueBetter: {
      type: Boolean,
      default: false,
    },
    cardTitle: {
      type: String,
      default: '',
    },
  },
  setup(props) {
    const displayValue = computed(() => {
      if (props.value === null || props.value === undefined || props.value === '') {
        return '-';
      }
      return props.value;
    });

    return {
      displayValue,
    };
  },
});
</script>
