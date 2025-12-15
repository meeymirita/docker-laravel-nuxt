<template>
  <div class="home__wrapper">
    <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125"/>

    <div class="wrapper">
      <HelloWorld msg="You did it!"/>
    </div>

  </div>
</template>

<script setup>

import HelloWorld from "@/components/HelloWorld.vue";
</script>

<style  scoped>
.home__wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 100%;
  gap: 50px;
}
</style>
