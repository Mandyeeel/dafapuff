<template>
	<admin-basic>
	    <md-table v-model="searched" md-sort="date" md-sort-order="desc">
	      <md-table-toolbar>
	        <div class="md-toolbar-section-start">
	          <h1 class="md-title">{{ name }}
	      		<span class="md-caption">餘{{ last_num }}{{ unit }}</span></h1>
	        </div>

	        <md-field md-clearable class="md-toolbar-section-end md-search-input">
	          <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" />
	        </md-field>
	      </md-table-toolbar>

	      <md-table-empty-state
	        md-label="No users found"
	        :md-description="`No user found for this '${search}' query. Try a different search term or create a new user.`">
	        <md-button class="md-primary md-raised" @click="newUser">Create New User</md-button>
	      </md-table-empty-state>

	      <md-table-row slot="md-table-row" slot-scope="{item}">
	        <md-table-cell md-label="時間" md-sort-by="date" md-numeric>{{ item.bought_date }}</md-table-cell>
	        <md-table-cell md-label="地點" md-sort-by="location">{{ item.bought_location }}</md-table-cell>
	        <md-table-cell md-label="品牌" md-sort-by="brand">{{ item.brand }}</md-table-cell>
	        <md-table-cell md-label="數量" md-sort-by="number">{{ item.bought_num }}</md-table-cell>
	        <md-table-cell md-label="金額" md-sort-by="price">{{ item.price }}</md-table-cell>
	        <md-table-cell md-label="過期日" md-sort-by="expire">{{ item.expire }}</md-table-cell>
	      </md-table-row>
	    </md-table>

	    <md-button @click="addStock()" class="md-fab md-mini md-primary md-fab-bottom-right">
	      <md-icon>add</md-icon>
	    </md-button>

	    <md-dialog :md-active.sync="showDialog" class="edit-dialog">
	      <md-dialog-title>{{ dialogTitle }}</md-dialog-title>
	      
        <md-datepicker v-model="selectedDate" md-immediately>
					<label>購買時間</label>
        </md-datepicker>

	      <md-field>
	        <label>購買地點</label>
	        <md-input required></md-input>
	      </md-field>
	      
	      <md-field>
	        <label>品牌</label>
	        <md-input required></md-input>
	      </md-field>

	      <md-field>
		      <label>價錢</label>
		      <span class="md-prefix">$</span>
		      <md-input></md-input>
		    </md-field>

	      <md-datepicker v-model="selectedDate" md-immediately>
					<label>到期日</label>
	      </md-datepicker>
	      

	      <md-dialog-actions>
	        <md-button class="md-primary" @click="showDialog = false">關閉</md-button>
	        <md-button class="md-primary" @click="updateIngredient()">儲存</md-button>
	      </md-dialog-actions>
	    </md-dialog>

	</admin-basic>
</template>

<script>
  const toLower = text => {
    return text.toString().toLowerCase()
  }

  const searchByName = (items, term) => {
    if (term) {
      return items.filter(item => toLower(item.name).includes(toLower(term)))
    }

    return items
  }

  export default {
    name: 'TableSearch',
    props: ['title','name','last_num','unit','stocks'],
    data: () => ({
      search: null,
      searched: [],
      selectedDate: new Date(),
      showDialog: false,
      dialogTitle: '新增紀錄'
    }),
    methods: {
      newUser () {
        window.alert('Noop')
      },
      searchOnTable () {
        this.searched = searchByName(this.users, this.search)
      },
      addStock() {
      	this.showDialog = true;
        this.dialogTitle = '新增紀錄';
      }
    },
    created () {
      this.searched = JSON.parse(this.stocks);
    }
  }
</script>

<style scoped>
	.md-search-input {
		max-width: 300px;
	}
  .edit-dialog {
    width: 60%;
    padding: 3em 5em;
  }
</style>