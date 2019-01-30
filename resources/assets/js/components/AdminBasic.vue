<template>
	<md-app md-mode="reveal">
	    <md-app-toolbar class="md-primary">
	      <md-button class="md-icon-button" @click="menuVisible = !menuVisible">
	        <md-icon>menu</md-icon>
	      </md-button>
	      <span class="md-title">原料列表</span>
	    </md-app-toolbar>

	    <md-app-drawer :md-active.sync="menuVisible">
	      <md-toolbar class="md-transparent" md-elevation="0">分類</md-toolbar>

	      <md-list>
	        <md-list-item>
	          <md-icon>local_grocery_store</md-icon>
	          <span class="md-list-item-text">原料</span>
	        </md-list-item>

	        <md-list-item>
	          <md-icon>cake</md-icon>
	          <span class="md-list-item-text">烘焙</span>
	        </md-list-item>
	      </md-list>
	    </md-app-drawer>

	    <md-app-content> 
			<slot></slot>
	    </md-app-content>
	</md-app>
</template>

<script>
	export default {
		data: () => ({
			menuVisible: false
		})
	}
</script>

<style scoped>
	.md-app {
		min-height: 100vh;
	}
</style>