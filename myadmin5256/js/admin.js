function userAction(id,action)
{
if(confirm('Are you sure?'))
{
	$('#st'+id).html('<img src="/images/ajax-loader.gif">');
	$.ajax({
		url:'ajax/ajaxCommon.php?action='+action+'&id='+id,
		type:'GET',
		success:function(msg){
				$('#loading').hide();
				if(action == 'suspend')
				{
					$('#st'+id).html('Suspended');
					$('#action1'+id).html('Active').attr('onclick','userAction('+id+',\'active\')');
					$('#action2'+id).html('-').attr('onclick','');
					$('#activeUser').html(parseInt($('#activeUser').html())-1);
					$('#suspendUser').html(parseInt($('#suspendUser').html())+1);
					$('#totalUser').focus();
				}
				if(action == 'ban')
				{
					$('#st'+id).html('Banned');
					$('#action1'+id).html('Active').attr('onclick','userAction('+id+',\'active\')');
					$('#action2'+id).html('-').attr('onclick','');
					$('#activeUser').html(parseInt($('#activeUser').html())-1);
					$('#bannedUser').html(parseInt($('#bannedUser').html())+1);
					$('#totalUser').focus();
				}
				if(action == 'active')
				{
					$('#st'+id).html('Active');
					$('#action1'+id).html('Suspend').attr('onclick','userAction('+id+',\'suspend11\')');
					$('#action2'+id).html('Ban').attr('onclick','userAction('+id+',\'ban\')');
					$('#activeUser').html(parseInt($('#activeUser').html())+1);
					$('#bannedUser').html(parseInt($('#bannedUser').html())-1);
					$('#totalUser').focus();
				
				}
			}
		});
	}
}

function deletePost(id)
{
if(confirm('Are you sure?'))
{
	$('#st'+id).html('<img src="/images/ajax-loader.gif">');
	$.ajax({
		url:'ajax/ajaxCommon.php?action=delete&id='+id,
		type:'GET',
		success:function(msg){
					$('#st'+id).html('Deleted');
					$('#img'+id).hide().attr('onclick','');
			}
		});
	}
}
function deleteAccount(id)
{
	if(confirm('All activities of this user will be permanent delete'))
	{
			$.ajax({
		url:'ajax/ajaxCommon.php?action=deleteAccount&id='+id,
		type:'GET',
		success:function(msg){
					alert('Deleted');
					$('#row'+id).hide();
			}
		});
		
	
	}
	
}