// JavaScript Document
//проверка, пусто ли поле
function emptyField(textObj)
{
 if(textObj.value.length==0) return true;
 for(var i=0;i<textObj.value.length;++i)
 {
  var ch=textObj.value.charAt(i);
  if(ch!=' ' && ch!='\t') return false;
 }
 return true;
}

//Подтверждение удаления
function ConfirmDelete()
{
  if (confirm("Удалить текущую запись?")) return true;
  return false;
}

//Только цифры
function IsInt(textObj)
{
 for(var i=0;i<textObj.value.length;++i)
 {
  var ch=textObj.value.charAt(i);
  if(ch<"0" || ch>"9") return false;
 }
 return true;
}