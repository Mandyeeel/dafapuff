<template>
	<admin-basic>
	    <md-table v-model="searched" md-sort="date" md-sort-order="desc" @md-selected="onSelect">
	      <md-table-toolbar>
	        <div class="md-toolbar-section-start">
	          <h1 class="md-title">{{ name }}
	      		<span class="md-caption">餘{{ last_num }}{{ unit }}</span></h1>
	        </div>

	        <md-field md-clearable class="md-toolbar-section-end md-search-input">
	          <md-input placeholder="Search" v-model="search" @input="searchOnTable" />
	        </md-field>
	      </md-table-toolbar>

	      <md-table-empty-state
	        md-label="No users found"
	        :md-description="`No user found for this '${search}' query. Try a different search term or create a new user.`">
	        <md-button class="md-primary md-raised" @click="newUser">Create New User</md-button>
	      </md-table-empty-state>

	      <md-table-row slot="md-table-row" slot-scope="{item}" md-selectable="single">
	        <md-table-cell md-label="時間" md-sort-by="date">{{ item.bought_date }}</md-table-cell>
	        <md-table-cell md-label="地點" md-sort-by="location">{{ item.bought_location }}</md-table-cell>
	        <md-table-cell md-label="品牌" md-sort-by="brand">{{ item.brand }}</md-table-cell>
	        <md-table-cell md-label="數量" md-sort-by="number" md-numeric>{{ item.bought_num }}{{ unit }}</md-table-cell>
	        <md-table-cell md-label="金額" md-sort-by="price" md-numeric>{{ item.price }}</md-table-cell>
	        <md-table-cell md-label="過期日" md-sort-by="expire">{{ item.expire }}</md-table-cell>
	      </md-table-row>
	    </md-table>
			
			<md-button v-if="selected" class="md-fab md-mini md-icon-button md-raised md-accent md-fab-bottom-left">
        <md-icon>delete</md-icon>
      </md-button>

	    <md-button @click="addStock()" class="md-fab md-mini md-primary md-fab-bottom-right">
	      <md-icon>add</md-icon>
	    </md-button>

	    <md-dialog :md-active.sync="showDialog" class="edit-dialog">
	      <md-dialog-title>{{ dialogTitle }}</md-dialog-title>
	      
        <md-datepicker v-model="stock.bought_date" md-immediately>
					<label>購買日</label>
        </md-datepicker>

	      <md-field>
	        <label>購買地點</label>
	        <md-input v-model="stock.location" required></md-input>
	      </md-field>
	      
	      <md-field>
	        <label>品牌</label>
	        <md-select v-model="stock.brand" name="brand" id="brand">
            <md-option v-for="brand in ingredientBrands" :key="brand" :value="brand">{{ brand }}</md-option>
          </md-select>
	      </md-field>

	      <md-field>
	        <label>數量({{ unit }})</label>
	        <md-input v-model="stock.bought_num" required></md-input>
	      </md-field>

	      <md-field>
		      <label>價錢</label>
		      <span class="md-prefix">$</span>
		      <md-input v-model="stock.price" required></md-input>
		    </md-field>

	      <md-datepicker v-model="stock.expire_date" md-immediately>
					<label>到期日</label>
	      </md-datepicker>
	      

	      <md-dialog-actions>
	        <md-button class="md-primary" @click="showDialog = false">關閉</md-button>
	        <md-button class="md-primary" @click="updateStock()">儲存</md-button>
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
    props: ['title','name','last_num','unit','stocks', 'ingredient','brands'],
    data: () => ({
      search: null,
      searched: [],
      selected: false,
      stock: {
      	ingredient: '',
      	bought_date: new Date(),
      	location: '',
      	bought_num: '',
      	brand: '',
      	price: '',
      	expire_date: new Date()
      },
      ingredientBrands: [],
      edit: false,
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
      fetchStocks(page_url) {
      	page_url = page_url || '/api/stock';
        fetch(page_url)
	        .then(res => res.json())
	        .then(res => {
	        	console.log(res.data)
	          this.searched = res.data;
	        })
	        .catch(err => console.log(err));
      },
      addStock() {
      	this.showDialog = true;
        this.dialogTitle = '新增紀錄';
      },
      updateStock() {
      	if(this.edit === false){
      		console.log(JSON.stringify(this.stock))
      		fetch('/api/stock', {
      			method: 'post',
      			body: JSON.stringify(this.stock),
            headers: {
              'content-type': 'application/json'
            }
      		})
	      		.then(res => res.json())
	      		.then(data => {
	      			this.stock.bought_date = new Date();
	      			this.stock.location = '';
	      			this.stock.bought_num = '';
	      			this.stock.brand = '';
	      			this.stock.price = '';
	      			this.stock.expire_date = new Date();
	      			alert('stock added');
	      			this.fetchStocks();
	      		})
	      		.catch(err => console.log(err));
      	}
      },
      onSelect (item) {
      	//出現項目操作
        this.selected = item != null;
      }
    },
    created () {
    	this.stock.ingredient = this.ingredient;
    	this.ingredientBrands = JSON.parse(this.brands);
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