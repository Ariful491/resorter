

export default {
    methods:{
        loadThumbnail: function (e) {
       let file=e.target.files[0];
            var reader = new FileReader();
            reader.onload = (e) =>{
                this.form.image = e.target.result;

            }
            reader.readAsDataURL(file);

        },
    }
}
