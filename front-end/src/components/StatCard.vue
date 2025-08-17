<template>
  <Card class="stat-card" :style="{ backgroundColor: color }">
    <template #title>
      <div class="flex justify-content-between align-items-center">
        <span>{{ title }}</span>
        <i :class="icon" class="stat-icon"></i>
      </div>
    </template>
    <template #content>
      <div class="stat-value">{{ value }}</div>
    </template>
  </Card>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    value: {
      type: [Number, String],
      required: true
    },
    icon: {
      type: String,
      default: 'pi pi-info-circle'
    },
    color: {
      type: String,
      default: 'var(--primary-color)'
    }
  }
};
</script>

<style scoped>
.stat-card {
  color: white;
  height: 100%;
}

.stat-icon {
  font-size: 1.5rem;
  opacity: 0.8;
}

.stat-value {
  font-size: 2rem;
  font-weight: bold;
  text-align: center;
  margin: 1rem 0;
}
</style>