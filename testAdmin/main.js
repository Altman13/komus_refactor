// JavaScript Document
//��������, ����� �� ����
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

//������������� ��������
function ConfirmDelete()
{
  if (confirm("������� ������� ������?")) return true;
  return false;
}

//������ �����
function IsInt(textObj)
{
 for(var i=0;i<textObj.value.length;++i)
 {
  var ch=textObj.value.charAt(i);
  if(ch<"0" || ch>"9") return false;
 }
 return true;
}