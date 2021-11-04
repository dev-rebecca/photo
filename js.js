// Post photo

const sample_image = document.getElementsByName('sample_image')[0];

sample_image.addEventListener('change', () => {

	upload_image(sample_image.files[0]);

});


const upload_image = (file) => {

	// check file type

	if(!['image/jpeg', 'image/png'].includes(file.type))
	{
		document.getElementById('uploaded_image').innerHTML = '<div>Only .jpg and .png image are allowed</div>';

		document.getElementsByName('sample_image')[0].value = '';
		
        return;
    }

    // check file size (< 2MB)
    if(file.size > 2 * 1024 * 1024)
    {
    	document.getElementById('uploaded_image').innerHTML = '<div>File must be less than 2 MB</div>';

    	document.getElementsByName('sample_image')[0].value = '';
        return;
    }

    const form_data = new FormData();

    form_data.append('sample_image', file);

    fetch("php.php", {
    	method:"POST",
    	body : form_data
    }).then(function(response){
    	return response.json();
    }).then(function(responseData){

    	document.getElementById('uploaded_image').innerHTML = '<div>Image Uploaded Successfully</div> <img src="'+responseData.image_source+'" />';

    	document.getElementsByName('sample_image')[0].value = '';

    });
}

// View photo
function viewPhoto (evt) {

  evt.preventDefault();
  const formData = new FormData();

  formData.append(evt.target[0].name, evt.target[0].value);

  fetch("php.php", 
    {
        method: 'POST',
        body: formData,
        credentials: 'include'
    }
  )
  .then (
    function(headers) {
      headers.text().then(function(body) {
        console.log(body);
        document.getElementById("myDiv").src = body;
      })
    }
  )
}
            
