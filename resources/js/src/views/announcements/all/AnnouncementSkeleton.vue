<template>
  <div>
    <div class="card">
      <div class="header">
        <div class="header-img skeleton" />
        <div
          class="title"
          data-title
        >
          <div class="skeleton skeleton-text" />
          <div class="skeleton skeleton-text" />
        </div>
      </div>
      <div data-body>
        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />

        <br>

        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />
        <div class="skeleton skeleton-text" />

      </div>
    </div>
  </div>
</template>

<style scoped>
.skeleton {
  opacity: 0.7;
  animation: skeleton-loading 1s linear infinite alternate;
}

.skeleton-text {
  width: 100%;
  height: 0.75rem;
  margin-bottom: 0.25rem;
  border-radius: 0.125rem;
}

.skeleton-text:last-child {
  margin-bottom: 0;
  width: 80%;
}

@keyframes skeleton-loading {
  0% {
    background-color: hsl(200, 20%, 70%);
  }

  100% {
    background-color: hsl(200, 20%, 95%);
  }
}

.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
  padding: 1rem;
}

.card {
  background-color: white;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px,
    rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
  padding: 16px;
  border-radius: 4px;
}

.header {
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
}

.header-img {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 100%;
  margin-right: 1rem;
  flex-shrink: 0;
}

.title {
  font-weight: bold;
  font-size: 1.25rem;
  text-transform: capitalize;
  word-wrap: none;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  flex-grow: 1;
}
</style>

<script>
export default {}
</script>
