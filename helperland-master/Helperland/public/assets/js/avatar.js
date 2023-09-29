const car_url = `${BASE_URL}/assets/img/avatar/car.png`;
const female_url = `${BASE_URL}/assets/img/avatar/female.png`;
const male_url = `${BASE_URL}/assets/img/avatar/male.png`;
const ship_url = `${BASE_URL}/assets/img/avatar/ship.png`;
const iron_url = `${BASE_URL}/assets/img/avatar/iron.png`;
const hat_url = `${BASE_URL}/assets/img/avatar/hat.png`;

// const car_url = "../assets/img/avatar/car.png";
// const female_url = "../assets/img/avatar/female.png";
// const male_url = "../assets/img/avatar/male.png";
// const ship_url = "../assets/img/avatar/ship.png";
// const iron_url = "../assets/img/avatar/iron.png";
// const hat_url = "../assets/img/avatar/hat.png";

$('[name="avatar"]').change(function(){
    let avatar = $('[name="avatar"]:checked').val();
    switch(avatar){
        case 'car': 
            $('.avatar').attr('src', car_url);
            break;
        case 'hat':
            $('.avatar').attr('src', hat_url);
            break;
        case 'male':
            $('.avatar').attr('src', male_url);
            break;
        case 'female':
            $('.avatar').attr('src', female_url);
            break;
        case 'iron':
            $('.avatar').attr('src', iron_url);
            break;
        case 'ship':
            $('.avatar').attr('src', ship_url);
            break;
    }
});
