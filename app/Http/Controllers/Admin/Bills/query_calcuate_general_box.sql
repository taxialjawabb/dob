
select 
	sum(take_money) as take_money,  sum(t.spend_money) as spend_money, (sum(take_money) - sum(t.spend_money)) total_money
	from 
	(
	select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
	count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
	sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
	count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
	sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
	from box_driver t1 
	left join admins ad on  t1.deposited_by  = ad.id and t1.id  where  t1.bond_state = 'deposited' and t1.payment_type <> 'internal transfer' and ad.name is not null     group by deposited_date , ad.id
	union all
	select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
	count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
	sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
	count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
	sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
	from box_vechile t1 
	left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited' and t1.payment_type <> 'internal transfer' and ad.name is not null    group by deposited_date , ad.id
	union all
	select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date,  
	count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
	sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
	count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
	sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
	from box_rider t1 
	left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited' and t1.payment_type <> 'internal transfer' and ad.name is not null    group by deposited_date , ad.id
	union all
	select  ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
	count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
	sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
	count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
	sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
	from box_nathriaat t1 
	left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited' and t1.payment_type <> 'internal transfer' and ad.name is not null    group by deposited_date , ad.id
	union all
	select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
	count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
	sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
	count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
	sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
	from box_user t1 
	left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited' and t1.payment_type <> 'internal transfer' and ad.name is not null    group by deposited_date , ad.id
	) t   ;