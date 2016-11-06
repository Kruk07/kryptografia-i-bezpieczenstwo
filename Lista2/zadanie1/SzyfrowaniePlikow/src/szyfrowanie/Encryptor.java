package szyfrowanie;

import java.io.Console;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintWriter;
import java.math.BigInteger;
import java.security.Key;
import java.security.KeyPair;
import java.security.KeyStore;
import java.security.KeyStoreException;
import java.security.NoSuchAlgorithmException;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.UnrecoverableKeyException;
import java.security.cert.Certificate;
import java.security.cert.CertificateException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Scanner;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.spec.GCMParameterSpec;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;

import org.apache.commons.codec.binary.Base64;

public class Encryptor {
	public static byte[] toByteArray(String s) {
	    return DatatypeConverter.parseHexBinary(s);
	}
    public static void encryptCBC(SecretKeySpec key, String initVector, File plik,String name) {
        try {
        	//String key=
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

        	
            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            SecretKeySpec skeySpec=key;
           // SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");

            Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec, iv);
            
        	int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}


            //byte[] encrypted = cipher.doFinal(value.getBytes());
            //System.out.println("encrypted string: "
                 //   + Base64.encodeBase64String(encrypted));

            //return Base64.encodeBase64String(encrypted);
			fis.close();
			outFile.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }

    }
    public static void decryptCBC(SecretKeySpec key, String initVector, File plik,String name) throws BadPaddingException {
        try {
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            //SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");
            SecretKeySpec skeySpec=key;
                    Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec, iv);

            
            int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}
			fis.close();
			outFile.close();
            
            //byte[] original = cipher.doFinal(Base64.decodeBase64(encrypted));
            
            //return new String(original, "UTF-8");
        } catch (Exception ex) {
            //ex.printStackTrace();
          
            throw new BadPaddingException();
        }
    }    
    
    
    public static void encryptCTR(SecretKeySpec key, String initVector, File plik,String name) {
        try {
        	//String key=
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

        	
            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            SecretKeySpec skeySpec=key;
           // SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");

            Cipher cipher = Cipher.getInstance("AES/CTR/PKCS5PADDING");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec, iv);
            
        	int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}


            //byte[] encrypted = cipher.doFinal(value.getBytes());
            //System.out.println("encrypted string: "
                 //   + Base64.encodeBase64String(encrypted));

            //return Base64.encodeBase64String(encrypted);
			fis.close();
			outFile.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }

    }
    public static void decryptCTR(SecretKeySpec key, String initVector, File plik,String name) throws BadPaddingException {
        try {
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            //SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");
            SecretKeySpec skeySpec=key;
                    Cipher cipher = Cipher.getInstance("AES/CTR/PKCS5PADDING");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec, iv);

            
            int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}
			fis.close();
			outFile.close();
            
            //byte[] original = cipher.doFinal(Base64.decodeBase64(encrypted));
            
            //return new String(original, "UTF-8");
        } catch (Exception ex) {
            //ex.printStackTrace();
          
            throw new BadPaddingException();
        }
    }    
    
    public static void encryptECB(SecretKeySpec key, String initVector, File plik,String name) {
        try {
        	//String key=
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

        	
            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            SecretKeySpec skeySpec=key;
           // SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");

            Cipher cipher = Cipher.getInstance("AES/ECB/PKCS5PADDING");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec);
            
        	int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}


            //byte[] encrypted = cipher.doFinal(value.getBytes());
            //System.out.println("encrypted string: "
                 //   + Base64.encodeBase64String(encrypted));

            //return Base64.encodeBase64String(encrypted);
			fis.close();
			outFile.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }

    }
    public static void decryptECB(SecretKeySpec key, String initVector, File plik,String name) throws BadPaddingException {
        try {
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

            IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            //SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");
            SecretKeySpec skeySpec=key;
                    Cipher cipher = Cipher.getInstance("AES/ECB/PKCS5PADDING");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec);

            
            int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}
			fis.close();
			outFile.close();
            
            //byte[] original = cipher.doFinal(Base64.decodeBase64(encrypted));
            
            //return new String(original, "UTF-8");
        } catch (Exception ex) {
            //ex.printStackTrace();
          
            throw new BadPaddingException();
        }
    }    
    
    public static void encryptGCM(SecretKeySpec key, String initVector, File plik,String name) {
        try {
        	//String key=
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);


        	
            //IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            SecretKeySpec skeySpec=key;
           // SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");

        	GCMParameterSpec spec=new GCMParameterSpec(96, toByteArray(initVector));
            Cipher cipher = Cipher.getInstance("AES/GCM/NOPADDING");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec,spec);
            
        	int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}


            //byte[] encrypted = cipher.doFinal(value.getBytes());
            //System.out.println("encrypted string: "
                 //   + Base64.encodeBase64String(encrypted));

            //return Base64.encodeBase64String(encrypted);
			fis.close();
			outFile.close();
        } catch (Exception ex) {
            ex.printStackTrace();
        }

    }
    public static void decryptGCM(SecretKeySpec key, String initVector, File plik,String name) throws BadPaddingException {
        try {
        	FileInputStream fis= null;
        	fis = new FileInputStream(plik);

            //IvParameterSpec iv = new IvParameterSpec(toByteArray(initVector));
            //SecretKeySpec skeySpec = new SecretKeySpec(toByteArray(key), "AES");
        	GCMParameterSpec spec=new GCMParameterSpec(96, toByteArray(initVector));

            SecretKeySpec skeySpec=key;
                    Cipher cipher = Cipher.getInstance("AES/GCM/NOPADDING");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec,spec);

            
            int bytesRead;
            byte[] inFragment = new byte[64];
    		FileOutputStream outFile = new FileOutputStream(name);
			while ((bytesRead = fis.read(inFragment)) != -1) {
        		byte[] outFragment = cipher.update(inFragment, 0, bytesRead);

				if (outFragment != null){
        			outFile.write(outFragment);					
				}

        	}
			byte[] outFragment = cipher.doFinal();
			if (outFragment != null){
				outFile.write(outFragment);			
			}
			fis.close();
			outFile.close();
            
            //byte[] original = cipher.doFinal(Base64.decodeBase64(encrypted));
            
            //return new String(original, "UTF-8");
        } catch (Exception ex) {
            //ex.printStackTrace();
          
            throw new BadPaddingException();
        }
    }    
    
    static int sprawdzCzyOK(String napis){
    	//char[] znaki={' ','A','a','E','e','I','i','O','o','U','u','Q','q','W','w',' ','Í','R','r','T','t','Y','y','”','Û','P','p','•','π','S','s','å','ú','D','d','F','f','G','g','H','h','J','j','K','k','L','l','£','≥','Z','z','Ø','ø','X','x','è','ü','C','c','∆','Ê','V','v','B','b','N','n','—','Ò','M','m','0','1','2','3','4','5','6','7','8','9','"','\'','!','?',',','.',';',':','\0','(',')','%','-'};
    	char[] znaki={' ','"','0','1','2','3','4','5','6','7','8','9','A','a','π','B','b','C','c','∆','Ê','D','d','E','e',' ','Í','F','f','G','g','H','h','I','i','J','j','K','k','L','l','£','≥','M','m','N','n','—','Ò','O','o','P','p','R','r','S','s','å','ú','T','t','U','u','”','Û','Q','q','V','v','W','w','X','x','Y','y','Z','z','Ø','ø','è','ü','(',')','[',']','{','}',',','.','-',':','~',';','?','/','%','\'','\0'};
    	boolean znak;
    	for (int i=0;i<napis.length()-2;i++){
    		znak=false;
    		for (int j=0;j<znaki.length;j++){
    			if(napis.charAt(i)==znaki[j]){
    				znak=true;
    				break;
    			}
    		}
    		if (znak==false){
    			return 0;
    		}
    	}
    	return 1;
    	
    }
    public static Key getKey(String keystore2){
    	try {
    		FileInputStream is = new FileInputStream(keystore2);
			KeyStore keystore = KeyStore.getInstance("JCEKS");
			//System.out.println("Enter password to KeyStore: ");
			//mystorepass
			//Scanner user_input = new Scanner(System.in);
			//String keystorepass=user_input.next();
			  Console console = System.console();
			  char passwordArray[] = console.readPassword("Enter password to KeyStore: ");
			  String keystorepass= new String(passwordArray);
			    //console.printf("Password entered was: %s%n", new String(passwordArray));
			keystore.load(is, keystorepass.toCharArray());
			
			
			//123456
			char passwordArray2[] = console.readPassword("Enter your secret password: ");
			  String pass= new String(passwordArray2);
			    //console.printf("Password entered was: %s%n", new String(passwordArray2));
			//String pass=user_input.next();
			//user_input.close();
	        String alias = "klucz";

	        Key key = keystore.getKey(alias, pass.toCharArray());
	        return key;
	        
	        
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return null;
    }
    
    
    public static void main(String[] args) throws BadPaddingException, IOException {
    	
    	String tryb=args[0];
    	String name=args[1];
    	String namewy=args[2];
    	String typ=args[3];
    	String keystore=args[4];
    	int trybn;

    	File plik = new File(name);
        String initVector = "e0f0d21485d3f90a09d95825d7c2ebd0";
        //String key="7477e315c60b2a98fce9398ed6814cc0e87d6784ed34458e4ba00de6a5f23d9b";
        Key key2 = getKey(keystore);
        SecretKeySpec key=(SecretKeySpec) key2;
    	if (tryb.equals("E")||tryb.equals("e")){
    		if(typ.equals("CBC")||typ.equals("cbc")){
    			encryptCBC(key, initVector,plik,namewy);
    		}else if(typ.equals("CTR")||typ.equals("ctr")){
    			encryptCTR(key, initVector,plik,namewy);
    		}else if(typ.equals("ECB")||typ.equals("ecb")){
    			encryptECB(key, initVector, plik,namewy);
    		}else if(typ.equals("GCM")||typ.equals("gcm")){
    			encryptGCM(key, initVector, plik,namewy);
    		}else{
    			System.err.println("NIEPOPRAWNA NAZWA TYPU");
    			return;
    		}
    		
    	}else if (tryb.equals("D")||tryb.equals("d")){
    		if(typ.equals("CBC")||typ.equals("cbc")){
    			decryptCBC(key, initVector,plik,namewy);
    		}else if(typ.equals("CTR")||typ.equals("ctr")){
    			decryptCTR(key, initVector,plik,namewy);
    		}else if(typ.equals("ECB")||typ.equals("ecb")){
    			decryptECB(key, initVector,plik,namewy);
    		}else if(typ.equals("GCM")||typ.equals("gcm")){
    			decryptGCM(key, initVector,plik,namewy);
    		}else{
    			System.err.println("NIEPOPRAWNA NAZWA TYPU");
    			return;
    		}
    	}else{
    		System.err.println("NIEPOPRAWNA NAZWA TRYBU");
    		return;
    	}
        //encryptCBC(key, initVector, message,plik,namewy);
        //encryptCTR(key, initVector, message,plik,namewy);
        //encryptECB(key, initVector, message,plik,namewy);
        //encryptGCM(key, initVector, message,plik,namewy);
         //decryptCBC(key, initVector,plik,namewy);
        //decryptCTR(key, initVector,plik,namewy);
        //decryptECB(key, initVector,plik,namewy);
        //decryptGCM(key, initVector,plik,namewy);
        //System.out.println("WYNIK: "+xd);
        
    }         
    

}