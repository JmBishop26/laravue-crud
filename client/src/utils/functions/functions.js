export function getInputValues(instance) {
  if (instance.title.trim()===''){
    return 0
  }else{
    return {
      title: instance.title,
      description: instance.description,
      status: instance.status===true?'complete':'ongoing',
      file: instance.file.name,
    };
  }
}

export function fileToLink(file){
  return URL.createObjectURL(file)
}
