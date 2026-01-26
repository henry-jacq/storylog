import bcrypt

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
