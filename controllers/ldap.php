<?php 
	
			
			$host = "ec-server";
			$domain = "ecepik.local";
			$basedn = "dc=ecepik,dc=local";
			$group = "EquipeCepik";
			$ds = ldap_connect("{$host}.{$domain}");
			
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
			
			$user = "grsevero"; //Administrative user
			$password = "123456";
			
			$r = @ldap_bind($ds, "{$user}@{$domain}", $password);
			if($r){
				echo 'usuario autenticado';
				
			}else{
				"Falha na autenticacao";
			}
			
			//Adiciona user
			if ($ds) {
				
				 // prepare data
			    $info["cn"] = "UserTest";
			    $info["sn"] = "Jones";
			    $info["mail"] = "jonj@example.com";
			    $info["objectclass"] = "user";
			
			    // add data to directory
			    $r = ldap_add($ds, "cn=EquipeCepik", $info);
			    if(!$f){
			    	echo 'Não foi possivel adicionar o usuário';
			    }else{
			    	echo "usuário adicionado com sucesso";
			    }
			
			    ldap_close($ds);
			
			}else{
				echo 'Não foi possivel conectar com o servidor';
			}
		 
		
	?>