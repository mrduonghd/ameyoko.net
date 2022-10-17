axios
  .get(
    'https://graph.facebook.com/17841562225126163/top_media?user_id=17841430027999072&access_token=EAA3IIw3Y7CsBAI9Pxa0gMIlzZBZC60NnvuBzEMJpOC9dGMaq20ndD1ZCxHaxglHXY5IeWZBXOm8ZCreiwQtbKzi6ZBvaJcZBZCzULIC67PlTx4FgoOmQR4iFg7n9WAGVA5mfMxExnATAC1nfwZC8tnh6SGZB26D0yIMtL5KZAsE6RMfteqUYJotDrKN&fields=id,media_type,media_url,permalink,like_count,comments_count,timestamp,children{id,media_url}&limit=8'
  )
  .then((instagram_data) => {
    var photos = '';
    const gallery_data = instagram_data.data.data;

    if (gallery_data.length > 0) {
      for (let i = 0; i < gallery_data.length; i++) {
        if (gallery_data[i].media_type == 'CAROUSEL_ALBUM') {
          photos +=
            '<li><a href="' +
            gallery_data[i].permalink +
            '" class="instagram-' +
            gallery_data[i].media_type.toLowerCase() +
            '" target="_blank" rel="nofollow" style="background:url(' +
            gallery_data[i].children.data[0].media_url +
            ') no-repeat center / cover;"></a></li>';

        } else {
          photos +=
            '<li><a href="' +
            gallery_data[i].permalink +
            '" class="instagram-' +
            gallery_data[i].media_type.toLowerCase() +
            '" target="_blank" rel="nofollow" style="background:url(' +
            gallery_data[i].media_url +
            ') no-repeat center / cover;"></a></li>';
        }
      }
    }

    document.querySelector('#instafeed').innerHTML = photos;
  })
  .catch((error) => {
    console.log(error);
  });
