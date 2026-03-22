import Modal from 'react-bootstrap/Modal';

const BootstrapModal = ({ id, showModal=true, setShowModal, size="sm", title="", children, error=false }) => {
    const additionalClass = error ? 'text-danger' : '';

    return (
        <>
            <Modal
                size={size}
                show={showModal}
                onHide={() => setShowModal(false)}
                aria-labelledby={id}
                contentClassName='rounded-4'
                centered
            >
                {title && (
                    <Modal.Header closeButton className={`text-center ${additionalClass}`} >
                        <Modal.Title id={id} className="w-100">
                            {title}
                        </Modal.Title>
                    </Modal.Header>
                )}
                <Modal.Body className='text-center'>{children}</Modal.Body>
            </Modal>
        </>
    );
};

export default BootstrapModal;
