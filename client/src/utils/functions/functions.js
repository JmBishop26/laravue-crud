import { Dialog } from 'quasar'

//these are the functions/helpers where http request is not involved


//function to assign values to the form
export function getInputValues(instance) {
  if (instance.title.trim()===''){
    return 0
  }else{
    const formData = new FormData()
    formData.append('title', instance.title)
    formData.append('description', instance.description)
    formData.append('status', instance.status===true?'complete':'ongoing')
    formData.append('file', instance.fileUpload)
    return formData
  }
}

//function to make the date in the table readable by human
export function readableDate(date){
  const inputDate = new Date(date);

  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
  };

  return inputDate.toLocaleDateString('en-US', options);
}

/*
  function to convert the file uploaded in /public/uploads in laravel (backend) to file object so that the
  file input can read the data again for editing tasks.
*/
export function toFileObject(response, fileName){

  const mime = getMimetype(fileName)

  const blob = new Blob([response.data], { type: mime });
  const fileObject = new File([blob], fileName, { type: mime});
  return fileObject
}

//function to get the Mimetype to convert the file back to its original file type
export function getMimetype(file) {
  if (file){

    const ext = file.split('.').pop();

    const mimeTypes = {
      jpg: 'image/jpeg',
      jpeg: 'image/jpeg',
      png: 'image/png',
      pdf: 'application/pdf',
      aac: 'audio/aac',
      avif: 'image/avif',
      csv: 'text/csv',
      doc:'application/msword',
      docx:'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      gif: 'image/gif',
      json:'application/json',
      txt:'text/plain',
      xlsx:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      xls:'application/vnd.ms-excel',
      //add more file types
    };

    return mimeTypes[ext] || 'application/octet-stream';
  }
}

//function to show alert after creating, editing, and deleting task from the table.
export async function showAlert(response){

  const dialog = {
    title: response.success?'Success':'Failed',
    message: await response.message,
    ok: 'OK',
  };

  Dialog.create(dialog)
    .onOk(() => {
      window.location.reload()
    })
}

//function to concatenate the url of laravel app and filename fetched from the database.
export function fileURL(fileName){
  const url = 'http://127.0.0.1:8000/uploads/'
  return url+fileName
}
