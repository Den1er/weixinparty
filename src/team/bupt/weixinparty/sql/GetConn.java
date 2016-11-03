package team.bupt.weixinparty.sql;

import java.sql.Connection;
import java.sql.DriverManager;

public class GetConn {
	public Connection getConnection(){
		Connection conn = null;
		try{
			Class.forName("com.mysql.jdbc.Driver");
			System.out.println("数据库驱动加载成功！");
			String url="jdbc:mysql://localhost:3306/db_database03";
			String user="root";
			String passWord="111";
			conn=DriverManager.getConnection(url,user,passWord);
			System.out.println("已成功与数据库建立连接！");
			}catch(Exception e){
				e.printStackTrace();
			}
		return conn;
	}

}
