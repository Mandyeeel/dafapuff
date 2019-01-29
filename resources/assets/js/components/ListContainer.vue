<template>
  <admin-basic>
    <div class="md-layout md-gutter">
      <div class="md-layout-item md-large-size-25 md-small-size-100">
        <md-field>
          <label>搜尋</label>
          <md-input></md-input>
        </md-field>
      </div>
    </div>

    <md-button @click="addIngredient()" class="md-fab md-mini md-primary md-fab-bottom-right">
      <md-icon>add</md-icon>
    </md-button>
    
    <div class="md-layout md-gutter">

      <div v-for="ingredient in ingredients" :key="ingredient.id" class="list-card md-layout-item md-large-size-25 md-small-size-100">
        <md-card md-with-hover>
          <md-ripple>
            <md-card-header>
              <md-card-header-text>
                <div class="md-title">{{ ingredient.name }}</div>
              </md-card-header-text>
              
              <md-menu md-size="big" md-direction="bottom-end">
                <md-button class="md-icon-button" md-menu-trigger>
                  <md-icon>more_vert</md-icon>
                </md-button>
                <md-menu-content>
                  <md-menu-item @click="editIngredient(ingredient)">
                    <span>編輯</span>
                    <md-icon>edit</md-icon>
                  </md-menu-item>

                  <md-menu-item @click="deleteIngredient(ingredient.id)">
                    <span>刪除</span>
                    <md-icon>delete</md-icon>
                  </md-menu-item>
                </md-menu-content>
              </md-menu>
            </md-card-header>

            <md-card-content>
              <div class="md-display-1">餘 {{ ingredient.last_num }}{{ ingredient.unit}}</div>
            </md-card-content>

            <md-card-actions md-alignment="space-between">
              <div class="md-caption">最後於 {{ ingredient.updated_at }} 編輯</div>
              <md-button class="md-primary md-icon-button"><md-icon>shopping_cart</md-icon><md-tooltip md-direction="top">採買</md-tooltip></md-button>
            </md-card-actions>
          </md-ripple>
        </md-card>
      </div>

    </div>
    
    <md-dialog :md-active.sync="showDialog" class="edit-dialog">
      <md-dialog-title>{{ dialogTitle }}</md-dialog-title>
      
      <md-field>
        <label>名稱</label>
        <md-input v-model="ingredient.name" required></md-input>
      </md-field>

      <md-chips class="md-primary" v-model="ingredient.brands" md-placeholder="增加品牌..">
        <label>品牌</label>
      </md-chips>

      <md-field>
        <label for="movie">單位</label>
        <md-select v-model="ingredient.unit" name="unit" id="unit">
          <md-option value="克">克</md-option>
          <md-option value="個">個</md-option>
        </md-select>
      </md-field>

      <md-field>
        <label>剩餘數量</label>
        <md-input v-model="ingredient.last_num" required></md-input>
        <span class="md-suffix">{{ ingredient.unit }}</span>
      </md-field>
      
      <md-field>
        <label>剩餘提醒數量</label>
        <md-input v-model="ingredient.alert_num"></md-input>
        <span class="md-suffix">{{ ingredient.unit }}</span>
      </md-field>

      <md-dialog-actions>
        <md-button class="md-primary" @click="showDialog = false">關閉</md-button>
        <md-button class="md-primary" @click="updateIngredient()">儲存</md-button>
      </md-dialog-actions>
    </md-dialog>
  </admin-basic>

</template>

<style scoped>
  .list-card {
    margin-bottom: 2em;
  }

  .edit-dialog {
    width: 60%;
    padding: 3em 5em;
  }
</style>

<script>

  export default {
    data: () => ({
      menuVisible: false,
      ingredients: [],
      ingredient: {
        name: '',
        unit: '克',
        last_num: '',
        alert_num: '',
        brands: []
      },
      showDialog: false,
      dialogTitle: '新增原料',
      edit: false
    }),
    created() {
      this.fetchIngredients();
    },
    methods: {
      fetchIngredients(page_url) {
        page_url = page_url || 'api/ingredient';
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.ingredients = res.data;
          })
          .catch(err => console.log(err));
      },
      addIngredient() {
        this.showDialog = true;
        this.dialogTitle = '新增原料';
      },
      editIngredient(ingredient) {
        this.edit = true;
        this.showDialog = true;
        this.dialogTitle = '編輯原料';
        this.ingredient.id = ingredient.id;
        this.ingredient.name = ingredient.name;
        this.ingredient.unit = ingredient.unit;
        this.ingredient.last_num = ingredient.last_num;
        this.ingredient.alert_num = ingredient.alert_num;
        this.ingredient.brands = JSON.parse(ingredient.brand);
      },
      updateIngredient() {

        if(this.edit === false){
          //add
          fetch('api/ingredient', {
            method: 'post',
            body: JSON.stringify(this.ingredient),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            this.ingredient.name = '';
            this.ingredient.unit = '克';
            this.ingredient.last_num = '';
            this.ingredient.alert_num = '';
            this.ingredient.brands = [];
            alert('ingredient added');
            this.fetchIngredients();
          })
          .catch(err => console.log(err))
        }else{
          //edit
          fetch('api/ingredient', {
            method: 'put',
            body: JSON.stringify(this.ingredient),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            alert('ingredient edited');
            this.fetchIngredients();
          })
          .catch(err => console.log(err))
        }
      },
      deleteIngredient(id) {
        if(confirm('確定刪除嗎？')){
          fetch('api/ingredient/'+id, {
            method: 'delete'
          })
          .then(res => res.json())
          .then(data => {
            alert('deleted');
            this.fetchIngredients();
          });
        }
      }
    }
  }
</script>