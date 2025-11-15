<script setup>

try {
  const data = await $fetch('http://localhost:8080/api/test')
} catch (e) {
  console.error(e)
}
console.log(data.value)
</script>

<template>

</template>