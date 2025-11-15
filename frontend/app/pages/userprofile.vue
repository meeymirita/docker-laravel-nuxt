<template>
  <div>

  </div>
</template>

<script setup>
const data = ref(null)

try {
  data.value = await $fetch('http://localhost:8080/api/test')
} catch (e) {
  console.error(e)
}

console.log(data.value)



</script>

<style lang="scss" scoped>

</style>