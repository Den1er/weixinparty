package team.bupt.weixinparty.util;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class DBUtils {
	private static Connection conn;
	static{
		try{
			Class.forName("com.mysql.jdbc.Driver");
			System.out.println("数据库驱动加载成功！");
			String url="jdbc:mysql://localhost:3306/party";
			String user="root";
			String passWord="";
			conn=DriverManager.getConnection(url,user,passWord);
			System.out.println("已成功与数据库建立连接！");
			}catch(Exception e){
				e.printStackTrace();
			}
	}
	
	public static ResultSet executeQuery(String sql){
		try {
			PreparedStatement statement = conn.prepareStatement(sql);
			ResultSet rs = statement.executeQuery();
			return rs;
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return null;
	}
	
	public static int executeUpdate(String sql){
		try {
			PreparedStatement statement = conn.prepareStatement(sql);
			int rs = statement.executeUpdate(sql);
			return rs;
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return 1;
	}
	
	public static void destory(){
		try {
			conn.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
}
