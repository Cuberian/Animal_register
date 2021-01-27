export default {
    methods: {
        getNowDate() {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            return today;
        },
        formatDate(stringDate) {
            let date = new Date(stringDate);

            let dd = date.getDate();
            if (dd < 10) dd = '0' + dd;

            let mm = date.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;

            let yyyy = date.getFullYear();

            return dd + '.' + mm + '.' + yyyy;
        },
        getDescription(traits) {
            let sizes = {
                'big' : 'большого размера',
                'small' : 'маленького размера',
                'medium' : 'среднего размера',
            }
            let wools = {
                'long_wool' : 'длинношерстный',
                'short_wool' : 'короткошерстный',
                'hard_wool' : 'жесткошерстный',
                'curly_wool': 'кудрявая',
            }
            return sizes[traits.size] + ', ' + wools[traits.wool]
        },
        backToRegister() {
            window.location.href = '/register';
        }
    }
}

