
var app = new Vue({
    el:"#app",
    data:{
        message:"Hello this is vue js",
        seen:true,
        todos: [
            { text: 'Learn JavaScript' },
            { text: 'Learn Vue' },
            { text: 'Build something awesome' }
          ],
        todo:""
    },
    methods: {
        addTodo:  async function(){
            this.todos.push({text:this.todo});
            this.todo = "";

            var request = await axios.get("http://localhost:81/pos/pos_backend/fetch.php");
            this.message = request.data.user_name;
        },
        removeTodo: function(){
            this.todos.pop();
        }
    }
})
