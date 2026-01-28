from cryptography.hazmat.primitives.ciphers.aead import AESGCM
from cryptography.hazmat.primitives.kdf.scrypt import Scrypt
from cryptography.hazmat.backends import default_backend 
import os, base64, bcrypt


MAX_BCRYPT_LEN = 72

def hash_password(password: str) -> str:
    # bcrypt hard limit
    if len(password.encode("utf-8")) > MAX_BCRYPT_LEN:
        raise ValueError("Password too long (max 72 bytes)")
    
    salt = bcrypt.gensalt()
    hashed = bcrypt.hashpw(password.encode("utf-8"), salt)
    return hashed.decode("utf-8")


def verify_password(password: str, hashed: str) -> bool:
    return bcrypt.checkpw(password.encode("utf-8"), hashed.encode("utf-8"))


def encrypt_text(key: bytes, plaintext: str) -> str:
    nonce = os.urandom(12)
    aes = AESGCM(key)
    cipher = aes.encrypt(nonce, plaintext.encode(), None)
    return base64.b64encode(nonce + cipher).decode()


def decrypt_text(key: bytes, ciphertext: str) -> str:
    raw = base64.b64decode(ciphertext)
    nonce, cipher = raw[:12], raw[12:]
    aes = AESGCM(key)
    return aes.decrypt(nonce, cipher, None).decode()


def prepare_salt():
    salt = os.urandom(16)
    return base64.b64encode(salt).decode()


def derive_journal_key(password: str, salt_b64: str) -> bytes:
    salt = base64.b64decode(salt_b64)
    kdf = Scrypt(salt=salt, length=32, n=2**14, r=8, p=1, backend=default_backend(),)
    return kdf.derive(password.encode("utf-8"))
