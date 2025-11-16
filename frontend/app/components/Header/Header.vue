<template>
  <header class="header">
    <div class="header__wrapper">

      <div class="header__navigation">
        <NuxtLink to="/" class="header__logo">
          LOGO
        </NuxtLink>
        <nav class="header__nav">
          <ul class="header__nav-list">
            <li>
              <NuxtLink to="/" >Главная</NuxtLink>
            </li>
          </ul>
        </nav>
      </div>


      <div class="header__search"></div>

      <div class="header__panels">
        <div class="upload">
          <button class="upload__icon">
            <Icon name="mdi:pencil-outline"   style="background-color: white"
                  size="24" />
          </button>
        </div>
        <div class="notification">
          <button class="notification__icon">
            <Icon name="mdi:bell-badge-outline"    style="background-color: white"
                  size="24" />
          </button>
        </div>
        <div class="account">
          <button class="account__icon">
            <Icon name="mdi:account-outline"   style="background-color: white"
                  size="24" />
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>