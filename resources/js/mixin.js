

export default {
    methods:{
        loadThumbnail: function (e) {
       let file=e.target.files[0];
            var reader = new FileReader();
            reader.onload = (e) =>{
                this.form.image = e.target.result;

            }
            reader.readAsDataURL(file);

        }, thumbnail: function (e) {
          return 'http://127.0.0.1:8000/'+e;

        },
    }
}
